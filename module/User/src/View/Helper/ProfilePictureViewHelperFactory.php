<?php

namespace User\View\Helper;

/**
 * Class ProfilePictureViewHelperFactory
 * @package User\View\Helper
 */
class ProfilePictureViewHelperFactory
{
    public function __invoke($container)
    {
        return new ProfilePictureViewHelper($container);
    }
}
