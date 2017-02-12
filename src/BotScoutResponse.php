<?php

namespace NicolasBeauvais\BotScout;

class BotScoutResponse
{
    protected $matched;

    protected $type;

    protected $all;

    protected $evaluation;

    protected $mail;

    protected $ip;

    protected $name;

    /**
     * BotScoutResponse constructor.
     */
    public function __construct($response)
    {
        $response = explode('|', $response);

        $this->matched = $response[0] === 'Y';
        $this->type = $response[1];

        if ($this->type === 'ALL') {
            $this->all = (int)$response[2];
            $this->evaluation = $response[3];
        } elseif ($this->type === 'MULTI') {
            $response = array_slice($response, 2);

            for ($index = 0; $index < count($response); $index += 2) {
                $this->{strtolower($response[$index])} = (int)$response[$index + 1];
            }
        } else {
            $this->{strtolower($this->type)} = (int)$response[2];
        }
    }

    public function getMatched() : bool
    {
        return $this->matched;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getAll()
    {
        return $this->all;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEvaluation()
    {
        return $this->evaluation;
    }

    public function isValid() : bool
    {
        return !$this->matched;
    }
}
