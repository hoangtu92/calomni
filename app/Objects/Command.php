<?php


class Command
{

    public $command = [];
    public $expected = null;
    public $not_expected = null;

    /**
     * Command constructor.
     * @param array $command
     * @param $expected
     * @param $not_expected
     */
    public function __construct(array $command, $expected, $not_expected)
    {
        $this->command = $command;
        $this->expected = $expected;
        $this->not_expected = $not_expected;
    }


    public function isSuccess($result){

        $check = false;
        if($this->expected != null){
            $check = preg_match($this->expected, $result);
        }
        if($this->not_expected != null){
            $check = !preg_match($this->not_expected, $result);
        }
        return $check;
    }

}
