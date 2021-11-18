<?php

namespace Mig\Bootstrap;

class Printer
{
    /**
     * Output text to console
     *
     * @param string $message
     * @return void
     */
    public function out($message)
    {
        echo $message;
    }

    /**
     * Output new line to console
     *
     * @return void
     */
    public function newline()
    {
        $this->out("\n");
    }

    /**
     * Output text to cosole in default layout
     *
     * @param string $message
     * @return void
     */
    public function display($message)
    {
        $this->out($message);
        $this->newline();
    }

    /**
     * Output text in red color as error message
     *
     * @param string $text
     * @return void
     */
    public function error($text)
    {
        $this->display("\e[31m" . $text . "\e[31m");
    }

    /**
     * Output text in green color as success message
     *
     * @param string $text
     * @return void
     */
    public function success($text)
    {
        $this->display("\e[92m" . $text . "\e[92m");
    }

    /**
     * Output text in yellow color as warning
     *
     * @param string $text
     * @return void
     */
    public function warning($text)
    {
        $this->display("\e[33m" . $text . "\e[33m");
    }

    /**
     * Output text in cyan color as info
     *
     * @param string $text
     * @return void
     */
    public function info($text)
    {
        $this->display("\e[96m" . $text . "\e[96m");
    }
    /**
     * Output text in purple color
     *
     * @param string $text
     * @return void
     */
    public function purple($text)
    {
        $this->display("\e[91m" . $text . "\e[91m");
    }

    /**
     * Output text in blue color
     *
     * @param string $text
     * @return void
     */
    public function blue($text)
    {
        $this->display("\e[94m" . $text . "\e[94m");
    }

    /**
     * Output text in magneta color
     *
     * @param string $text
     * @return void
     */
    public function magenta($text)
    {
        $this->display("\e[95m" . $text . "\e[95m");
    }
}
