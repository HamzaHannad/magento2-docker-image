<?php declare(strict_types = 1);

use Symfony\Component\Dotenv\Dotenv;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/.env');
    }

    private function callDockerCompose()
    {
        return 'docker-compose';
    }

    public function build()
    {
        $this->taskExec($this->callDockerCompose() . ' build')->run();
    }

    public function up()
    {
        $this->taskExec($this->callDockerCompose() . ' up -d')->run();
    }

    public function down()
    {
        $this->taskExec($this->callDockerCompose() . ' down')->run();
    }

    public function ps()
    {
        $this->taskExec($this->callDockerCompose() . ' ps')->run();
    }

    public function magentoComposerInstall()
    {
        $magentoVersion = $_ENV['MAGENTO_VERSION'];
        $cmd = <<< EOF
            docker exec -it --user 1000 phpfpm bash -c 'composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition=$magentoVersion && mv project-community-edition/*  . && rm -rf project-community-edition/'
        EOF;

        $this->taskExec($cmd)->run();
    }

    public function init()
    {
        $this->taskExec($this->callDockerCompose() . ' build && ' . $this->callDockerCompose() . ' up -d')->run();
    }

    public function shell()
    {
        $this->taskExec('docker exec -it phpfpm bash')->run();
    }

    public function restart()
    {
        $this->taskExec($this->callDockerCompose() . ' down && ' . $this->callDockerCompose() . ' up -d')->run();
    }

}
