<?php

namespace tlab\imap;

/**
 * Class IncomingMail
 * @package tlab\imap
 *
 * @author 2012 by Barbushin Sergey     <barbushin@gmail.com>
 * @author 2015 by Roopan Valiya Veetil <yiioverflow@gmail.com>
 * @author 2016 by Monzon Traore        <monzon@traore.ru>
 */
class IncomingMail
{
    /** @var integer */
    public $id;

    /** @var string */
    public $date;

    /** @var string */
    public $subject;

    /** @var string */
    public $fromName;

    /** @var string */
    public $fromAddress;

    /** @var array */
    public $to = [];

    /** @var string */
    public $toString;

    /** @var array */
    public $cc = [];

    /** @var array */
    public $replyTo = [];

    /** @var string */
    public $textPlain;

    /** @var string */
    public $textHtml;

    /** @var string */
    public $inReplyTo;

    /** @var string */
    public $messageId;

    /** @var string */
    public $references;

    /**
     * @var IncomingMailAttachment[]
     */
    protected $attachments = [];

    /**
     * @param IncomingMailAttachment $attachment
     */
    public function addAttachment(IncomingMailAttachment $attachment)
    {
        $this->attachments[$attachment->id] = $attachment;
    }

    /**
     * @return IncomingMailAttachment[]
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Get array of internal HTML links placeholders
     * @return array attachmentId => link placeholder
     */
    public function getInternalLinksPlaceholders()
    {
        return preg_match_all('/=["\'](ci?d:([\w\.%*@-]+))["\']/i', $this->textHtml, $matches)
            ? array_combine($matches[2], $matches[1])
            : [];
    }

    /**
     * @param string $baseUri
     *
     * @return string
     */
    public function replaceInternalLinks($baseUri)
    {
        $baseUri = rtrim($baseUri, '\\/') . '/';
        $fetchedHtml = $this->textHtml;

        foreach($this->getInternalLinksPlaceholders() as $attachmentId => $placeholder) {
            if (isset($this->attachments[$attachmentId])) {
                $fetchedHtml = str_replace(
                    $placeholder,
                    $baseUri . basename($this->attachments[$attachmentId]->filePath),
                    $fetchedHtml
                );
            }
        }

        return $fetchedHtml;
    }
}
