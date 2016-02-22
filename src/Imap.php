<?php

namespace tlab\imap;

use Yii;
use yii\base\InvalidConfigException;

/**
 * Class    Imap Class can be used for connecting and extracting Email messages.
 * @package tlab\imap
 *
 * @author 2012 by Barbushin Sergey     <barbushin@gmail.com>
 * @author 2015 by Roopan Valiya Veetil <yiioverflow@gmail.com>
 * @author 2016 by Monzon Traore        <monzon@traore.ru>
 */
class Imap extends Mailbox
{
    /** @var array */
    private $_connection = [];    

    /**
     * @param array
     * @throws InvalidConfigException on invalid argument.
     */
    public function setConnection($connection)
    {
        if (!is_array($connection)) {
            throw new InvalidConfigException(
                'You should set connection params in your config. Please read yii2-imap doc for more info'
            );
        }

        $this->_connection = $connection;
    }

    /**
     * @return array
     */
    public function getConnection()
    {
        $this->_connection = $this->createConnection();

        return $this->_connection;
    }

    /**
     * @return $this
     * @throws \tlab\imap\Exception
     */
    public function createConnection()
    {
        $this->imapPath = $this->_connection['imapPath'];
        $this->imapLogin = $this->_connection['imapLogin'];
        $this->imapPassword = $this->_connection['imapPassword'];
        $this->serverEncoding = $this->_connection['serverEncoding'];
        $this->attachmentsDir = $this->_connection['attachmentsDir'];

        if ($this->attachmentsDir) {
            if (!is_dir($this->attachmentsDir)) {
                throw new Exception('Directory "' . $this->attachmentsDir . '" not found');
            }

            $this->attachmentsDir = rtrim(realpath($this->attachmentsDir), '\\/');
        }

        return $this;
    }
}
