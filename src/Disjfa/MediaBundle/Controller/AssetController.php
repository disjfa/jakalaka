<?php

namespace Disjfa\MediaBundle\Controller;

use DateTime;
use Disjfa\MediaBundle\Entity\Asset;
use Disjfa\MediaBundle\Form\Type\AssetType;
use Disjfa\MediaBundle\Form\Type\ImportAssetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

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
        return $this->render('DisjfaMediaBundle:Asset:index.html.twig', [
            'assets' => $this->getDoctrine()->getRepository(Asset::class)->findAll(),
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
        if($form->isValid()) {
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

        while(trim($folderName, '/') !== '') {
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
     * @param Asset $asset
     * @param File $file
     */
    private function updateAssetWithFile(Asset $asset, File $file) {
        $asset->setMimeType($file->getMimeType());
        $asset->setSize($file->getSize());
        $asset->setPath($file->getRealPath());
        $asset->setExtension($file->getExtension());

        $em = $this->getDoctrine()->getManager();
        $em->persist($asset);
        $em->flush();
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
     * @Route("/{asset}", name="disjfa_media_asset_show")
     */
    public function showAction(Asset $asset)
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
}
