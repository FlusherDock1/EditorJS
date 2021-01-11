<?php namespace ReaZzon\Editor\Classes\Plugins\LinkTool;

use Illuminate\Http\Request;
use ReaZzon\Editor\Classes\Exceptions\PluginErrorException;
use ReaZzon\Editor\Classes\Plugins\LinkTool\Resources\LinkResource;

/**
 * LinkTool Plugin
 * @package ReaZzon\Editor\Classes\Plugins\LinkTool
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class Plugin
{
    /**
     * LinkTool constructor
     */
    public function __invoke(Request $request)
    {
        $url = $request->get('url');
        if (empty($url) || filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new PluginErrorException;
        }

        $link = OpenGraph::fetch($url);
        return new LinkResource($link);
    }
}
