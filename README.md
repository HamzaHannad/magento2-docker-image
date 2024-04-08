#### Installation of Magento 2 project with Docker.

**Steps:**
+ Clone the project into your directory.
+ Before setup, ensure the following:
  + Make sure ``Robo`` is installed on your machine.
  + Replace your authentication keys in the ``.env`` file. You can obtain them from [Here](https://account.magento.com/applications/customer/login/?client_id=10906dd964b2dcc6befafab4f567ce6b&redirect_uri=https%3A%2F%2Fcommercemarketplace.adobe.com%2Fsso%2Faccount%2FoauthCallback%2F&response_type=code&scope=adobe_profile&state=803890819861194a4c391a8e4d8f1823).
    
+ Run 
  ```bash 
  make
  ```
  ```bash
  robo shell
  ```
    ```bash
    bin/magento setup:install --base-url=http://my.magento.test \
                --db-host=mysql --db-name=magentodb --db-user=root --db-password=root \
                --admin-firstname=admin --admin-lastname=admin --admin-email=admin@admin.com \
                --admin-user=admin --admin-password=admin123 --language=en_US \
                --currency=USD --timezone=America/Chicago --use-rewrites=1 \
                --search-engine=elasticsearch7 --elasticsearch-host=elasticsearch \
                --elasticsearch-port=9200
    ```
  ```bash
  bin/magento setup:config:set --backend-frontname='admin'
  ```
  <br />
*Optional commands :*

```bash
bin/magento deploy:mode:set developer.
```

```bash
bin/magento maintenance:disable.
```
```bash
bin/magento sampledata:deploy.
```
```bash
bin/magento cache:disable layout full_page block_html translate
```
```bash
bin/magento module:disable Magento_AdminAdobeImsTwoFactorAuth Magento_TwoFactorAuth
```

### Notes

`database name = magentodb`

`url = `http://my.magento.test

`admin url = `http://my.magento.test/admin

`admin username = admin`

`admin password = admin123`

### Robo Commands

*Start all the services*
```bash 
robo up
```
*Stop all the services*
```bash
robo down
```

*Restart all the services*
```bash
robo restart
```

*Access the Magento container's shell*
```bash
robo shell
```