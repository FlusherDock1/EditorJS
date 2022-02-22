<?php namespace ReaZzon\Editor\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * RefreshStaticPages Command
 */
class RefreshStaticPages extends Command
{
    /**
     * @var string name is the console command name
     */
    protected $name = 'editor:refresh.static-pages';

    /**
     * @var string description is the console command description
     */
    protected $description = 'Resaving all static pages';

    /**
     * handle executes the console command
     */
    public function handle()
    {
        $this->info('Start of resaving...');
        $pages = \RainLab\Pages\Classes\Page::sortBy('title')->lists('title', 'baseFileName');

        foreach($pages as $fileName => $fileTitle) {
            $page = \RainLab\Pages\Classes\Page::loadCached(\Cms\Classes\Theme::getActiveTheme(), $fileName);
            $page->save();
        }
        $this->info('End of resaving...');
    }

    /**
     * getArguments get the console command arguments
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * getOptions get the console command options
     */
    protected function getOptions()
    {
        return [];
    }
}
