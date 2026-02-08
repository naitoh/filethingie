<?php

use PHPUnit\Framework\TestCase;

class FtUtilTest extends TestCase
{
    // --- ft_get_bytes ---

    public function testGetBytesKilobytes(): void
    {
        $this->assertEquals(1024, ft_get_bytes('1K'));
        $this->assertEquals(2048, ft_get_bytes('2k'));
    }

    public function testGetBytesMegabytes(): void
    {
        $this->assertEquals(1048576, ft_get_bytes('1M'));
        $this->assertEquals(2097152, ft_get_bytes('2m'));
    }

    public function testGetBytesGigabytes(): void
    {
        $this->assertEquals(1073741824, ft_get_bytes('1G'));
        $this->assertEquals(2147483648, ft_get_bytes('2g'));
    }

    public function testGetBytesPlainNumber(): void
    {
        $this->assertEquals(512, ft_get_bytes('512'));
        $this->assertEquals(0, ft_get_bytes('0'));
    }

    // --- ft_get_ext ---

    public function testGetExtSimpleExtension(): void
    {
        $this->assertEquals('txt', ft_get_ext('document.txt'));
        $this->assertEquals('png', ft_get_ext('image.png'));
        $this->assertEquals('php', ft_get_ext('index.php'));
    }

    public function testGetExtMultipleDots(): void
    {
        $this->assertEquals('gz', ft_get_ext('archive.tar.gz'));
        $this->assertEquals('bak', ft_get_ext('file.name.bak'));
    }

    public function testGetExtNoExtension(): void
    {
        $this->assertEquals('', ft_get_ext('README'));
        $this->assertEquals('', ft_get_ext('Makefile'));
    }

    // --- ft_get_nice_filename ---

    public function testGetNiceFilenameNoLimit(): void
    {
        $this->assertEquals('longfilename.txt', ft_get_nice_filename('longfilename.txt'));
        $this->assertEquals('file.png', ft_get_nice_filename('file.png', -1));
    }

    public function testGetNiceFilenameTruncated(): void
    {
        $result = ft_get_nice_filename('verylongfilename.txt', 5);
        $this->assertEquals('veryl....txt', $result);
    }

    public function testGetNiceFilenameShortEnough(): void
    {
        $result = ft_get_nice_filename('short.txt', 20);
        $this->assertEquals('short.txt', $result);
    }

    public function testGetNiceFilenameNoExtension(): void
    {
        $result = ft_get_nice_filename('verylongfilenamenoext', 5);
        $this->assertEquals('veryl...', $result);
    }

    // --- ft_get_nice_filesize ---

    public function testGetNiceFilesizeBytes(): void
    {
        $this->assertEquals('500&nbsp;b', ft_get_nice_filesize(500));
        $this->assertEquals('1&nbsp;b', ft_get_nice_filesize(1));
    }

    public function testGetNiceFilesizeKilobytes(): void
    {
        $result = ft_get_nice_filesize(2048);
        $this->assertEquals('2&nbsp;Kb', $result);
    }

    public function testGetNiceFilesizeMegabytes(): void
    {
        $result = ft_get_nice_filesize(5242880);
        $this->assertEquals('5&nbsp;MB', $result);
    }

    public function testGetNiceFilesizeEmpty(): void
    {
        $this->assertEquals('&mdash;', ft_get_nice_filesize(0));
        $this->assertEquals('&mdash;', ft_get_nice_filesize(''));
    }

    // --- ft_get_root ---

    public function testGetRoot(): void
    {
        $this->assertEquals(DIR, ft_get_root());
    }

    // --- ft_stripslashes ---

    public function testStripslashesPassthrough(): void
    {
        $this->assertEquals('hello', ft_stripslashes('hello'));
        $this->assertEquals("it's a test", ft_stripslashes("it's a test"));
        $this->assertEquals('path/to/file', ft_stripslashes('path/to/file'));
    }
}
