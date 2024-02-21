<?php
namespace Tests;

use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    protected string $tempDir = __DIR__ . '/tmp';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'filesystems.disks.local.root' => $this->tempDir,
            'filesystems.disks.public.root' => $this->tempDir,
        ]);

        $this->cleanTempDir();

        $this->migrateWithSeed();
    }

    protected function migrateWithSeed()
    {
        //
    }

    protected function getPackageProviders($app): array
    {
        return [
            //
        ];
    }

    protected function tearDown(): void
    {
        $this->cleanTempDir();
    }

    protected function cleanTempDir()
    {
        File::deleteDirectory($this->tempDir);
        File::ensureDirectoryExists($this->tempDir);
    }
}
