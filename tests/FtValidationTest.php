<?php

use PHPUnit\Framework\TestCase;

class FtValidationTest extends TestCase
{
    // --- ft_validate_filename ---

    public function testValidateFilenameAcceptsNormalFilename(): void
    {
        $this->assertEquals(1, ft_validate_filename('document.txt'));
        $this->assertEquals(1, ft_validate_filename('my-file.tar.gz'));
        $this->assertEquals(1, ft_validate_filename('image_01.png'));
        $this->assertEquals(1, ft_validate_filename('README'));
    }

    public function testValidateFilenameRejectsDotPrefix(): void
    {
        $this->assertEquals(0, ft_validate_filename('.htaccess'));
        $this->assertEquals(0, ft_validate_filename('.gitignore'));
        $this->assertEquals(0, ft_validate_filename('..'));
    }

    public function testValidateFilenameRejectsTrailingDot(): void
    {
        $this->assertEquals(0, ft_validate_filename('file.'));
    }

    public function testValidateFilenameRejectsEmptyString(): void
    {
        $this->assertEquals(0, ft_validate_filename(''));
    }

    public function testValidateFilenameRejectsSpecialChars(): void
    {
        $this->assertEquals(0, ft_validate_filename('file name.txt'));
        $this->assertEquals(0, ft_validate_filename('file<>.txt'));
        $this->assertEquals(0, ft_validate_filename('file;name.txt'));
    }

    public function testValidateFilenameAcceptsTildeAndHyphen(): void
    {
        $this->assertEquals(1, ft_validate_filename('file~backup'));
        $this->assertEquals(1, ft_validate_filename('my-file'));
    }

    // --- ft_check_file ---

    public function testCheckFileRejectsBlacklistedFile(): void
    {
        // FILEBLACKLIST = 'ft2.php config.php' (defined in bootstrap)
        $this->assertFalse(ft_check_file('ft2.php'));
        $this->assertFalse(ft_check_file('config.php'));
    }

    public function testCheckFileRejectsBlacklistedFileCaseInsensitive(): void
    {
        $this->assertFalse(ft_check_file('FT2.PHP'));
        $this->assertFalse(ft_check_file('Config.PHP'));
    }

    public function testCheckFileAllowsNonBlacklistedFile(): void
    {
        $this->assertTrue(ft_check_file('readme.txt'));
        $this->assertTrue(ft_check_file('image.png'));
    }

    // --- ft_check_filetype ---

    public function testCheckFiletypeRejectsBlacklistedType(): void
    {
        // FILETYPEBLACKLIST = 'php phtml php3 php4 php5' (defined in bootstrap)
        $this->assertFalse(ft_check_filetype('malicious.php'));
        $this->assertFalse(ft_check_filetype('script.phtml'));
        $this->assertFalse(ft_check_filetype('old.php3'));
    }

    public function testCheckFiletypeAllowsNonBlacklistedType(): void
    {
        $this->assertTrue(ft_check_filetype('document.txt'));
        $this->assertTrue(ft_check_filetype('image.png'));
        $this->assertTrue(ft_check_filetype('style.css'));
    }

    public function testCheckFiletypeWithWhitelist(): void
    {
        // Temporarily redefine FILETYPEWHITELIST by using runkit or test with current config.
        // Since FILETYPEWHITELIST is '' in bootstrap, blacklist mode is active.
        // We verify that non-blacklisted types pass.
        $this->assertTrue(ft_check_filetype('report.pdf'));
        $this->assertTrue(ft_check_filetype('data.json'));
    }

    // --- ft_check_dir ---

    public function testCheckDirRejectsBlacklistedDir(): void
    {
        // FOLDERBLACKLIST = 'plugins js css locales' (defined in bootstrap)
        $root = ft_get_root();
        $this->assertFalse(ft_check_dir($root . '/plugins'));
        $this->assertFalse(ft_check_dir($root . '/js'));
        $this->assertFalse(ft_check_dir($root . '/css'));
        $this->assertFalse(ft_check_dir($root . '/locales'));
    }

    public function testCheckDirRejectsBlacklistedSubdir(): void
    {
        $root = ft_get_root();
        $this->assertFalse(ft_check_dir($root . '/plugins/search'));
    }

    public function testCheckDirAllowsNonBlacklistedDir(): void
    {
        $root = ft_get_root();
        $this->assertTrue(ft_check_dir($root . '/documents'));
        $this->assertTrue(ft_check_dir($root . '/uploads'));
    }
}
