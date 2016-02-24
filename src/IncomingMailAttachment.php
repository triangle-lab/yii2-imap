<?php

namespace tlab\imap;

/**
 * Class    IncomingMailAttachment
 * @package tlab\imap
 */
class IncomingMailAttachment
{
    /** @var integer */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $filePath;

    /** @var integer */
    public $size;

    /** @var string */
    public $contentType;

    /** @var string */
    public $folder;

    /** @var string */
    public $extension;

    /** @var string */
    public $file;
}
