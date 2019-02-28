<?php

namespace Maduser\Minimal\Cli;

/**
 * Class Table
 *
 * @package Maduser\Minimal\Cli
 */
class Table
{
    /**
     * @param      $str
     * @param bool $newLine
     */
    public static function write($str, $newLine = true)
    {
        echo $newLine ? $str . "\n" : $str;
    }

    /**
     * @param string $str
     * @param int    $length
     * @param string $ph
     *
     * @return string
     */
    public static function pad(string $str, int $length, string $ph = ' '): string
    {
        return str_pad($str, $length, $ph);
    }

    /**
     * @param array $tbody
     * @param array $thead
     */
    public static function make($tbody = [], $thead = [])
    {
        $data = array_merge($tbody, $thead);
        $widths = self::getColWidths($data);
        $totalWidth = self::getTotalWidth($widths);

        foreach ($thead as $row) {

            self::write(' ');
            self::write(self::pad('', $totalWidth, '-'));

            $str = '|';
            $colIndex = 0;
            foreach ($row as $col) {
                $str .= ' ' . self::pad($col, $widths[$colIndex]) . ' |';
                $colIndex++;
            }

            self::write($str);

            self::write(self::pad('', $totalWidth, '-'));

        }

        foreach ($tbody as $row) {
            $str = '|';
            $colIndex = 0;
            foreach ($row as $col) {
                !is_object($col) || $col = get_class($col);
                $str .= ' ' . self::pad($col, $widths[$colIndex], ' ') . ' |';
                $colIndex++;
            }

            self::write($str);
        }

        self::write(self::pad('', $totalWidth, '-'));
        self::write(' ');
    }

    /**
     * @param $data
     *
     * @return array
     */
    public static function getColWidths($data)
    {
        $widths = [];

        foreach ($data as $row) {
            $colIndex = 0;
            foreach ($row as $col) {
                !is_object($col) || $col = get_class($col);
                if (!isset($widths[$colIndex]) || strlen($col) > $widths[$colIndex]) {
                    $widths[$colIndex] = strlen($col);
                }

                $colIndex++;
            }
        }

        return $widths;
    }

    /**
     * @param $widths
     *
     * @return int
     */
    public static function getTotalWidth($widths)
    {
        $total = 0;
        foreach ($widths as $width) {
            $total += $width + 3;
        }

        return $total + 1;
    }
}