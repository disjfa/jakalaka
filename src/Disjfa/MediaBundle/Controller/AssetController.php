<?php

declare(strict_types=1);

namespace Disjfa\MediaBundle\Controller;

use DateTime;
use Disjfa\MediaBundle\Entity\Asset;
use Disjfa\MediaBundle\Form\Type\AssetType;
use Disjfa\MediaBundle\Form\Type\ImportAssetType;
use Intervention\Image\ImageManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @Route("/media")
 */
class AssetController extends Controller
{
    /**
     * @Route("/", name="disjfa_media_asset_index")
     */
    public function indexAction()
    {
        $assets = $this->getDoctrine()->getRepository(Asset::class)->findAll();

        return $this->render('DisjfaMediaBundle:Asset:index.html.twig', [
            'assets' => $assets,
        ]);
    }

    /**
     * @Route("/import", name="disjfa_media_asset_import")
     */
    public function importAction(Request $request)
    {
        $filesystem = new Filesystem();

        $files = new Finder();
        $files->depth('== 0');

        $directories = new Finder();
        $directories->depth('== 0');

        if ($request->query->has('folder') && $filesystem->exists($request->query->get('folder'))) {
            $currentFolder = $request->query->get('folder');
        } else {
            $currentFolder = $this->getParameter('kernel.root_dir');
        }

        $form = $this->createForm(ImportAssetType::class);
        $form->get('folder')->setData($currentFolder);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $importFolder = $form->get('folder')->getData();
            foreach ($files->files()->in($importFolder) as $file) {
                $asset = new Asset($this->getUser());
                $asset->setName($file->getFilename());
                $asset->setOriginalName($file->getFilename());

                $newFile = new File($file->getRealPath());
                $this->updateAssetWithFile($asset, $newFile);
            }

            return $this->redirectToRoute('disjfa_media_asset_index');
        }

        $crum = [];
        $folderName = $currentFolder;

        while (trim($folderName, '/') !== '') {
            $folder = new File($folderName, false);
            $crum[] = $folder;

            $folderName = dirname($folder);
        }

        return $this->render('DisjfaMediaBundle:Asset:import.html.twig', [
            'files' => $files->files()->in($currentFolder),
            'directories' => $directories->directories()->in($currentFolder),
            'currentFolder' => $currentFolder,
            'crum' => array_reverse($crum),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create", name="disjfa_media_asset_create")
     */
    public function createAction(Request $request)
    {
        $asset = new Asset($this->getUser());
        $form = $this->createForm(AssetType::class, $asset);

        $form->handleRequest($request);
        if ($form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            $date = new DateTime();
            $useDir = $this->getParameter('disjfa_media.assets_folder') . '/' . $this->getUser()->getId() . '/' . $date->format('Y/m');
            $fs = new Filesystem();
            if (false === $fs->exists($useDir)) {
                $fs->mkdir($useDir);
            }

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($useDir, $fileName);

            $newFile = new File($useDir . '/' . $fileName);

            $asset->setOriginalName($file->getClientOriginalName());
            $this->updateAssetWithFile($asset, $newFile);

            return $this->redirectToRoute('disjfa_media_asset_index');
        }

        return $this->render('DisjfaMediaBundle:Asset:form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{asset}/show", name="disjfa_media_asset_show")
     */
    public function showAction(Asset $asset)
    {
        return $this->render('DisjfaMediaBundle:Asset:show.html.twig', [
            'asset' => $asset,
        ]);
    }

    /**
     * @Route("/{asset}/preview", name="disjfa_media_asset_preview")
     */
    public function previewAction(Asset $asset, Request $request)
    {
        if (false === $asset->isImage()) {
            // todo
            exit;
        }

        $fileName = $this->getParameter('disjfa_media.assets_folder') . '/cache/' . $asset->getId() . '/' . $asset->getId() . '.' . $asset->getExtension();
        try {
            $cacheFile = new File($fileName);
            $eTag = md5_file($fileName);

            if (in_array($eTag, $request->getETags()) || $request->headers->get('If-Modified-Since') === gmdate('D, d M Y H:i:s', $cacheFile->getMTime()) . ' GMT') {
                $response = new Response();
                $response->headers->set('Content-Type', $cacheFile->getMimeType());
                $response->headers->set('Last-Modified', gmdate('D, d M Y H:i:s', $cacheFile->getMTime()) . ' GMT');
                $response->headers->set('ETag', $eTag);
                $response->setPublic();
                $response->setStatusCode(304);

                return $response;
            }
        } catch (FileNotFoundException $e) {
            // no asset found. Go on, create one.
        }

        if ( ! is_dir(dirname($fileName))) {
            mkdir(dirname($fileName), 0755, true);
        }

        try {
            $file = new File($asset->getPath());
        } catch (FileNotFoundException $e) {
            return $this->render('DisjfaMediaBundle:Asset:asset_not_found.html.twig', [
                'asset' => $asset,
            ]);
        }

        $manager = new ImageManager(['driver' => 'imagick']);
        $image = $manager->make($asset->getPath());
        $image->fit(800, 450);
        $image->save($fileName);

        $cacheFile = new File($fileName);
        $eTag = md5_file($fileName);

        $streamResponse = new StreamedResponse();
        $streamResponse->headers->set('Content-Type', $cacheFile->getMimeType());
        $streamResponse->headers->set('Content-Length', $cacheFile->getSize());
        $streamResponse->headers->set('ETag', $eTag);
        $streamResponse->headers->set('Last-Modified', gmdate('D, d M Y H:i:s', $cacheFile->getMTime()) . ' GMT');

        $streamResponse->setCallback(function () use ($fileName) {
            readfile($fileName);
        });

        return $streamResponse;
    }

    /**
     * @Route("/{asset}/download", name="disjfa_media_asset_download")
     */
    public function downloadAction(Asset $asset)
    {
        try {
            $file = new File($asset->getPath());
        } catch (FileNotFoundException $e) {
            return $this->render('DisjfaMediaBundle:Asset:asset_not_found.html.twig', [
                'asset' => $asset,
            ]);
        }

        return new BinaryFileResponse($file);
    }

    /**
     * @param Asset $asset
     * @param File  $file
     */
    private function updateAssetWithFile(Asset $asset, File $file)
    {
        $asset->setMimeType($file->getMimeType());
        $asset->setSize($file->getSize());
        $asset->setPath($file->getRealPath());
        $asset->setExtension($file->getExtension());

        $em = $this->getDoctrine()->getManager();
        $em->persist($asset);
        $em->flush();
    }
}
