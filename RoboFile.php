<?php

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
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
        $cmd = <<< EOF
            docker exec -it --user 1000 phpfpm bash -c 'composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition=2.4.6 && mv project-community-edition/*  . && rm -rf project-community-edition/'
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
