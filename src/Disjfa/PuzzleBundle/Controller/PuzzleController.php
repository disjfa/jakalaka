<?php

namespace Disjfa\PuzzleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/puzzle")
 */
class PuzzleController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $image = 'https://images.unsplash.com/photo-1417325384643-aac51acc9e5d';
        $width = 2448;
        //$height = 3264;
        $height = $width / 16 * 9;

        $w = 1040;
        $h = $w / 16 * 9;

        $columns = [];
        $colY = 6;
        $colX = 5;

        $realWidth = floor($width / $colX);
        $realHeight = floor($height / $colY);

        $blockWidth = floor($w / $colX);
        $blockHeight = floor($h / $colY);

        for ($i = 0; $i < $colX; $i++) {
            for ($j = 0; $j < $colY; $j++) {
                if (isset($columns[$i][$j])) {
                    continue;
                }

                $sizeX = mt_rand(1, 3);
                $sizeX = $i + $sizeX > $colX ? $colX - $i : $sizeX;
                $maxX = $sizeX;
                $sizeY = mt_rand(1, 3);
                $sizeY = $j + $sizeY > $colY ? $colY - $j : $sizeY;
                $maxY = $sizeY;

                for ($mx = $i; $mx < $i + $sizeX; $mx++) {
                    if (isset($columns[$mx])) {
                        $maxX = $mx - $i < $maxX ? $mx - $i + 1 : $maxX;
                    }
                    for ($my = $j; $my < $j + $sizeY; $my++) {
                        if (isset($columns[$mx][$my])) {
                            $maxY = $my - $j < $maxY ? $my - $j + 1 : $maxY;
                        }
                    }
                }
                $sizeX = $maxX;
                $sizeY = $maxY;
                for ($mx = $i; $mx < $i + $sizeX; $mx++) {
                    for ($my = $j; $my < $j + $sizeY; $my++) {
                        $columns[$mx][$my] = false;
                    }
                }

                $iWidth = floor($blockWidth * $sizeX) + ($sizeX * 2) - 2;
                $iHeight = floor($blockHeight * $sizeY) + ($sizeY * 2) - 2;

                $params = [
                    'w' => $iWidth,
                    'h' => $iHeight,
                    'rect' => implode(',', [
                        $i * $realWidth,
                        $j * $realHeight,
                        $realWidth * $sizeX,
                        $realHeight * $sizeY
                    ])
                ];

                $columns[$i][$j] = [
                    'image' => $image . '?' . http_build_query($params, '&amp;'),
                    'styles' => [
                        'left' => $i * $blockWidth + ($i * 2),
                        'top' => $j * $blockHeight + ($j * 2),
                        'width' => $iWidth,
                        'height' => $iHeight,
                        'x' => $sizeX,
                        'y' => $sizeY,
                    ],
                ];
            }
            ksort($columns[$i]);
        }
        ksort($columns);

//        echo "<pre>";
//        print_r($columns);
//        exit;

        return $this->render('DisjfaPuzzleBundle:Puzzle:index.html.twig', [
            'columns' => $columns,
        ]);
    }
}
