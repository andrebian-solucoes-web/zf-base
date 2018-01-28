<?php

namespace BaseApplication\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class ZapLoading
 * @package BaseApplication\View\Helper
 */
class ZapLoading extends AbstractHelper
{
    /**
     * @param int $width
     * @param int $height
     * @param string $customClass
     *
     * @return string
     */
    public function __invoke($width = 50, $height = 50, $customClass = '')
    {
        echo <<<EOL
            <style>
                /*
                    Zap Loading
                 */
                .spinner-container {
                    -webkit-animation: rotate 2s linear infinite;
                    animation: rotate 2s linear infinite;
                    z-index: 2;
                }
                
                .spinner-container .path {
                    stroke-dasharray: 1, 150;
                    stroke-dashoffset: 0;
                    stroke: #2c3e50;
                    stroke-linecap: round;
                    -webkit-animation: dash 1.5s ease-in-out infinite;
                    animation: dash 1.5s ease-in-out infinite;
                }
                
                @keyframes rotate {
                    100% {
                        transform: rotate(360deg);
                    }
                }
                
                @-webkit-keyframes rotate {
                    100% {
                        -webkit-transform: rotate(360deg);
                    }
                }
                
                @keyframes dash {
                    0% {
                        stroke-dasharray: 1, 150;
                        stroke-dashoffset: 0;
                    }
                    50% {
                        stroke-dasharray: 90, 150;
                        stroke-dashoffset: -35;
                    }
                    100% {
                        stroke-dasharray: 90, 150;
                        stroke-dashoffset: -124;
                    }
                }
                
                @-webkit-keyframes dash {
                    0% {
                        stroke-dasharray: 1, 150;
                        stroke-dashoffset: 0;
                    }
                    50% {
                        stroke-dasharray: 90, 150;
                        stroke-dashoffset: -35;
                    }
                    100% {
                        stroke-dasharray: 90, 150;
                        stroke-dashoffset: -124;
                    }
                }
                
                @keyframes appear {
                    0% {
                        opacity: 0.5;
                        transform: scaleY(0);
                    }
                    100% {
                        opacity: 1;
                        transform: scaleY(1);
                    }
                }
                
                @-webkit-keyframes appear {
                    0% {
                        opacity: 0.5;
                        transform: scaleY(0);
                    }
                    100% {
                        opacity: 1;
                        transform: scaleY(1);
                    }
                }
            </style>
EOL;

        $loading = '<svg class="spinner-container ' . $customClass . '" width="' . $width . 'px" height="' . $height . 'px" viewBox="0 0 52 52"><circle class="path" cx="26px" cy="26px" r="20px" fill="none" stroke-width="4px"></circle></svg>';

        return $loading;
    }
}
