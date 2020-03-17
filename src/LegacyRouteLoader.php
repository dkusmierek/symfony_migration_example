<?php declare(strict_types=1);

namespace App;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class LegacyRouteLoader extends Loader
{
    const LEGACY_CONTROLLER = "App\Controller\LegacyController::loadLegacyScript";
    const DEFAULT_WEB_DIR = __DIR__ . "/../legacy/web";

    /**
     * @var string
     */
    private $webDir;

    public function __construct(?string $webDir = null)
    {
        $this->webDir = $webDir ?? self::DEFAULT_WEB_DIR;
    }

    public function load($resource, $type = null): RouteCollection
    {
        $collection = new RouteCollection();
        $finder = new Finder();
        $finder->sortByName();
        $finder->files()->name('*.php');

        /** @var SplFileInfo $legacyScriptFile */
        foreach ($finder->in($this->webDir) as $legacyScriptFile) {
            $filename = basename($legacyScriptFile->getRelativePathname(), '.php');
            $routeName = sprintf('app.legacy.%s', str_replace('/', '__', $filename));

            if ("index.php" === $legacyScriptFile->getRelativePathname()) {
                $collection->add('app.legacy.home_index', new Route("/{path}", [
                    '_controller' => self::LEGACY_CONTROLLER,
                    'requestPath' => '/' . $legacyScriptFile->getRelativePathname(),
                    'legacyScript' => $legacyScriptFile->getPathname(),
                ], ['path' => '.*']));
                continue;
            }

            $collection->add($routeName, new Route($legacyScriptFile->getFilenameWithoutExtension() . "{path}", [
                '_controller' => self::LEGACY_CONTROLLER,
                'requestPath' => '/' . $legacyScriptFile->getRelativePathname(),
                'legacyScript' => $legacyScriptFile->getPathname(),
            ], ['path' => '.*']));
        }

        return $collection;
    }

    public function supports($resource, $type = null): bool
    {
        return $type === 'legacy_routes';
    }
}
