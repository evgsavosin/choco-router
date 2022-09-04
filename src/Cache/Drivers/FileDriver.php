<?php 

declare(strict_types=1);

namespace ChocoRouter\Cache\Drivers;

use ChocoRouter\Cache\CacheKey;
use InvalidArgumentException;

use function sys_get_temp_dir;
use function is_writable;
use function file_exists;
use function mkdir;
use function file_put_contents;
use function str_replace;
use function var_export;
use function sprintf;

final class FileDriver implements DriverInterface
{
    /** @var string CACHE_DIRECTORY_NAME */
    private const CACHE_DIRECTORY_NAME = 'choco-router';

    private array $data = [];

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        private ?string $directory = null
    ) {
        if ($this->directory !== null && !is_writable($this->directory)) {
            throw new InvalidArgumentException("Cache directory \"{$this->directory}\" not writeable.");
        }

        $this->directory = $directory ?? sys_get_temp_dir() . DIRECTORY_SEPARATOR . self::CACHE_DIRECTORY_NAME;    

        if (file_exists($this->directory) === false) {
            mkdir($this->directory);
        }
    }

    private function makePath(CacheKey $key): string
    {
        return $this->directory . DIRECTORY_SEPARATOR . ($key->value) . '.php';
    }

    public function get(CacheKey $key): mixed
    {
        $path = $this->makePath($key);

        if (array_key_exists($key->value, $this->data)) {
            return $this->data[$key->value];
        }

        if (($this->data[$key->value] = @include($path)) === false) {
            return null;
        }

        return $this->data[$key->value];
    }

    public function set(CacheKey $key, mixed $value): mixed
    {
        $this->data[$key->value] = $value;

        file_put_contents(
            $this->makePath($key), 
            sprintf('<?php return %s;', str_replace(["\n", ' '], '', var_export($value, true))), 
            LOCK_EX
        );

        return $value;
    }

    public function delete(CacheKey $key): void
    {
        unset($this->data[$key->value]);
        @unlink($this->makePath($key));
    }
}