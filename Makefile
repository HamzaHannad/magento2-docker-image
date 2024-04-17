.PHONY: all

SHELL := /bin/zsh
HOME_DIR := $(HOME)
USER_VOLUMES := .ssh .composer

all: create-root-directory add-url-to-hosts init magento2-composer-install restart

create-root-directory:
	source ${HOME_DIR}/.zshrc && mkdir magento

add-url-to-hosts:
	sudo -- sh -c "echo '127.0.0.1 my.magento.test' >> /etc/hosts"

init:
	source ${HOME_DIR}/.zshrc && robo init

magento2-composer-install:
	source ${HOME_DIR}/.zshrc && robo magento:composer-install

restart:
	source ${HOME_DIR}/.zshrc && robo restart