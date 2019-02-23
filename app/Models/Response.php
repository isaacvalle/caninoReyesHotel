<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    private $message; // String
    private $status_code; //int
    private $data; //array
    private $ok; // bool

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * @param mixed $status_code
     */
    public function setStatusCode($status_code): void
    {
        $this->status_code = $status_code;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getOk()
    {
        return $this->ok;
    }

    /**
     * @param mixed $ok
     */
    public function setOk($ok): void
    {
        $this->ok = $ok;
    }
}
