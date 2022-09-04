<?php 

declare(strict_types=1);

namespace ChocoRouter\Cache\Drivers;

use InvalidArgumentException;

use function sys_get_temp_dir;
use function is_writable;
use function file_exists;
use function mkdir;
use function file_put_contents;
use function str_replace;
use function var_export;
use function sprintf;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
final class FileDriver implements DriverInterface
{
    /** @var string NAME */
    public const NAME = 'filesystem';

    /** @var string CACHE_DIRECTORY_NAME */
    private const CACHE_DIRECTORY_NAME = 'choco-router';

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        private ?string $directory = null
    ) {
        if (
            $this->directory !== null 
            && !is_writable($this->directory)
        ) {
            throw new InvalidArgumentException("Cache directory \"{$this->directory}\" not writeable.");
        }

        $this->directory = $directory ?? sys_get_temp_dir() . DIRECTORY_SEPARATOR . self::CACHE_DIRECTORY_NAME;    

        if (file_exists($this->directory) === false) {
            mkdir($this->directory);
        }
    }

    private function makePath(string $key): string
    {
        return $this->directory . DIRECTORY_SEPARATOR . $key . '.php';
    }

    public function get(string $key): mixed
    {
        $path = $this->makePath($key);

        if (($data = @include($path)) === false) {
            return null;
        }

        return $data;
    }

    public function set(string $key, mixed $value): mixed
    {
        file_put_contents(
            $this->makePath($key), 
            sprintf('<?php return %s;', str_replace(["\n", ' '], '', var_export($value, true))), 
            LOCK_EX
        );

        return $value;
    }

    public function delete(string $key): void
    {
        @unlink($this->makePath($key));
    }
}