<?php namespace Maduser\Minimal\Cli;

/**
 * Class Console
 *
 * @package Maduser\Minimal\Cli
 */
class Console implements ConsoleInterface
{
    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @var array
     */
    protected $options = [];

    private $fgColors = array();
    private $bgColors = array();

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     *
     * @return Console
     */
    public function setArguments(array $arguments): Console
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return Console
     */
    public function setOptions(array $options): Console
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Console constructor.
     */
    public function __construct()
    {
        $this->arguments = $this->fetchArguments();
        $this->options = $this->fetchOptions();

        $this->fgColors['black'] = '0;30';
        $this->fgColors['dark_gray'] = '1;30';
        $this->fgColors['blue'] = '0;34';
        $this->fgColors['light_blue'] = '1;34';
        $this->fgColors['green'] = '0;32';
        $this->fgColors['light_green'] = '1;32';
        $this->fgColors['cyan'] = '0;36';
        $this->fgColors['light_cyan'] = '1;36';
        $this->fgColors['red'] = '0;31';
        $this->fgColors['light_red'] = '1;31';
        $this->fgColors['purple'] = '0;35';
        $this->fgColors['light_purple'] = '1;35';
        $this->fgColors['brown'] = '0;33';
        $this->fgColors['yellow'] = '1;33';
        $this->fgColors['light_gray'] = '0;37';
        $this->fgColors['white'] = '1;37';

        $this->bgColors['black'] = '40';
        $this->bgColors['red'] = '41';
        $this->bgColors['green'] = '42';
        $this->bgColors['yellow'] = '43';
        $this->bgColors['blue'] = '44';
        $this->bgColors['magenta'] = '45';
        $this->bgColors['cyan'] = '46';
        $this->bgColors['light_gray'] = '47';
    }

    /**
     * @return array
     */
    public function fetchArguments(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function fetchOptions(): array
    {
        global $argv;

        if (! is_array($argv)) {
            return [];
        }

        $args = array_slice($argv, 3);
        $options = [];

        foreach ($args as $arg) {
            if (preg_match('/^--([^=]+)=(.*)/', $arg, $match)) {
                $options[$match[1]] = $match[2];
            } else {
                if (preg_match('/^--([^=]+)/', $arg, $match)) {
                    $options[$match[1]] = true;
                }
            }
        }

        return $options;
    }

    /**
     * @param int $index
     *
     * @return mixed|null
     */
    public function argument(int $index)
    {
        return isset($this->arguments[$index]) ? $this->arguments[$index] : null;
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function option($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    /**
     * @param      $str
     * @param bool $newLine
     */
    public function write($str, $newLine = true)
    {
        echo $newLine ? $str . "\n" : $str;
    }

    /**
     * @param      $str
     * @param null $fg
     * @param null $bg
     */
    public function line($str, $fg = null, $bg = null)
    {
        $string = "";

        if (isset($this->fgColors[$fg])) {
            $string .= "\033[" . $this->fgColors[$fg] . "m";
        }

        if (isset($this->bgColors[$bg])) {
            $string .= "\033[" . $this->bgColors[$bg] . "m";
        }

        $string .= $str . "\033[0m";

        $this->write($string);
    }


    /**
     * @param string $str
     * @param int    $length
     * @param string $ph
     *
     * @return string
     */
    public function pad(string $str, int $length, string $ph = ' '): string
    {
        return str_pad($str, $length, $ph);
    }

    /**
     * @param array $tbody
     * @param array $thead
     */
    public function table($tbody = [], $thead = [])
    {
        Table::make($tbody, $thead);
    }

    /**
     * @param int $code
     */
    public function exit($code = 0)
    {
        exit($code);
    }
}