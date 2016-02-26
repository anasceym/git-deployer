<?php 
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repository;

class GitCommand extends Command {
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'git:pull {repository_id} {--tag=}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "To run git pull inside server";
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $repo_id = $this->argument('repository_id');
        $repo = Repository::find($repo_id);

        if(!$repo) {
            throw new \Exception('No repository with id '.$repo_id.' found.');
        }

        // Make sure we're in the right directory
        $this->info('Changind directory to : ' . $repo->local_path);
        chdir($repo->local_path);

        exec( 'git reset --hard HEAD', $output);
        $this->printOutputInfo($output);

        exec( 'git fetch', $output);
        $this->printOutputInfo($output);

        exec( 'git pull ' . $repo->remote . ' ' . $repo->branch, $output);
        $this->printOutputInfo($output);

        $tag = $this->option('tag');
        if($tag) {
            exec( 'git checkout tags/' . $tag, $output);
            $this->printOutputInfo($output);
        }

        echo exec( 'chmod -R og-rx .git' );

        $this->info('Succesfully run git pull for '.$repo->title);

        return true;
    }

    /**
     * This method is just a little helper to print and output array.
     * @param $output Array of output to be printed.
     */
    private function printOutputInfo($output) {
        if(is_array($output)) {
            foreach($output as $out) {
                $this->info($out);
            }
        }
    }
}