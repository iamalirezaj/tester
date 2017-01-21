<?php

namespace Josh\Tester;

class Tester {

    /**
     * defined tests
     *
     * @var array
     */
    protected $tests = [];

    /**
     * defined a new line string
     *
     * @var string
     */
    const NEWLINE = "\n";

    /**
     * Tester constructor.
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since 17 Jan 2017
     * @param $name
     * @param callable $suit
     */
    public function __construct($name, callable $suit)
    {
        call_user_func($suit,$this);

        $this->exec($name);
    }

    /**
     * Make a new test
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since 17 Jan 2017
     * @param callable $callback
     * @return void
     */
    public function test($title = null,callable $callback)
    {
        $this->tests[] = [
            "title" => $title,
            "status" => $callback(static::class)
        ];
    }

    /**
     * Excecute the tests
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since 17 Jan 2017
     * @param $name
     */
    private function exec($name)
    {
        $asserts = 0;

        $this->line("Tester 0.1 by Alireza Josheghani and contributors.",true);

        if(empty($this->tests)){
            $this->warning("No tests executed!");
            exit(0);
        }

        $dashs = "";

        for($i=0;$i < 50;$i++){
            $dashs .= "-";
        }

        $this->line($name . " " . $dashs,true);

        $index = 1;

        foreach ($this->tests as $test){

            if(! is_null($test['title'])){
                $this->line($index++ . ". " . $test['title']);
            }

            if($test['status'] === 1){
                $this->line("\033[31m ✖ \033[0m",true);
                $this->danger("Faild (" . count($this->tests) . " tests, " . $asserts . " assertions)");
                exit(1);
            } else {
                $this->line("\033[32m ✔ \033[0m",true);
                $asserts++;
            }
        }

        $this->green("OK (" . count($this->tests) . " tests, " . $asserts . " assertions)");
        exit(0);
    }

    /**
     * Error status
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since 17 Jan 2017
     * @return int|null
     */
    public function error()
    {
        return $this->status("faild");
    }

    /**
     * Success status
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since 17 Jan 2017
     * @return int|null
     */
    public function success()
    {
        return $this->status("success");
    }

    /**
     * call a status
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since 17 Jan 2017
     * @param $status
     * @return int|null
     */
    public function status($status)
    {
        switch ($status){
            case "1":
            case 'success':
                return 0;
            case "0":
            case "faild":
            case "error":
                return 1;
        }

        return null;
    }

    /**
     * Make a success message
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since 17 Jan 2017
     * @param $message
     * @return mixed
     */
    private function green($message)
    {
        return print_r("\e[30;48;5;22m" . $message . "\e[49m\n");
    }

    /**
     * Make a warning message
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since 17 Jan 2017
     * @param $message
     * @return mixed
     */
    private function warning($message)
    {
        return print_r("\e[30;43;5;82m" . $message . "\e[49m\n");
    }

    /**
     * Make a new message
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since 17 Jan 2017
     * @param $message
     * @return mixed
     */
    private function line($message,$newLine = false)
    {
        return print_r($message . ($newLine ? "\n\n" : null));
    }

    /**
     * Make a danger message
     * 
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since 17 Jan 2017
     * @param $message
     * @return mixed
     */
    private function danger($message)
    {
        return print_r("\e[41m" . $message . "\e[49m\n");
    }
}
