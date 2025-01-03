#### Installation of Magento 2 project with Docker.

**Steps:**
+ Clone the repository.
+ Access to the Magento-2-Docker-Setup directory.
  ```bash
  cd Magento-2-Docker-Setup
  ```
+ Before setup, ensure the following:
  + Make sure <a href="https://robo.li/" target="_blank">Robo</a>``(PHP task runner)`` is installed on your machine.
  + The project includes a default `.env` file with predefined values. You can modify these values to suit your specific requirements.
    + `COMPOSER_AUTH`: This variable holds the authentication credentials for accessing the Magento repository. It should be a valid JSON string containing the username and password. You can obtain them from [Here](https://account.magento.com/applications/customer/login/?client_id=10906dd964b2dcc6befafab4f567ce6b&redirect_uri=https%3A%2F%2Fcommercemarketplace.adobe.com%2Fsso%2Faccount%2FoauthCallback%2F&response_type=code&scope=adobe_profile&state=803890819861194a4c391a8e4d8f1823).
    + `PHP_IMAGE`: Specifies the PHP version image to be used. For example, *php:8.1-rc-fpm*.
    + `MAGENTO_VERSION`: Indicates the version of Magento to be installed. For example, *2.4.6*.
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
### Optional commands
```bash
bin/magento deploy:mode:set developer
```
```bash
bin/magento maintenance:disable
```
```bash
bin/magento cache:disable layout full_page block_html translate
```
```bash
bin/magento module:disable Magento_AdminAdobeImsTwoFactorAuth Magento_TwoFactorAuth
```
<br />

### Varnish Configuration
- Run

```bash
bin/magento config:set system/full_page_cache/caching_application 2
```
```bash
bin/magento setup:config:set --http-cache-hosts=varnish:80
```
```bash
bin/magento config:set system/full_page_cache/varnish/access_list "localhost,php-fpm,web"
```
```bash
bin/magento config:set system/full_page_cache/varnish/backend_host web
```
```bash
bin/magento config:set system/full_page_cache/varnish/backend_port 8080
```

  <br />

### Install sample-data
- Run

```bash
bin/magento sampledata:deploy
```
```bash
bin/magento module:enable Magento_CustomerSampleData Magento_MsrpSampleData Magento_CatalogSampleData Magento_DownloadableSampleData Magento_OfflineShippingSampleData Magento_BundleSampleData Magento_ConfigurableSampleData Magento_ThemeSampleData Magento_ProductLinksSampleData Magento_ReviewSampleData Magento_CatalogRuleSampleData Magento_SwatchesSampleData Magento_GroupedProductSampleData Magento_TaxSampleData Magento_CmsSampleData Magento_SalesRuleSampleData Magento_SalesSampleData Magento_WidgetSampleData Magento_WishlistSampleData
```
```bash
bin/magento setup:upgrade
```
 <br />

### Setting up Grunt

#### 1 - Accessing the Container as Root User
```bash
docker exec -u root -it phpfpm bash
```
#### 2 - Installing Grunt CLI Globally
```bash
npm install -g grunt-cli
```
#### 3 - Copying Configuration Files
```bash
cp package.json.sample package.json
cp Gruntfile.js.sample Gruntfile.js
cp grunt-config.json.sample grunt-config.json
```
#### 4 - Installing Dependencies
```bash
npm install
```
#### 5 - Creating Local Themes Configuration File
```bash
cd dev/tools/grunt/configs
cp themes.js local-themes.js
```
#### 6 - Symlink Grunt to a Standard Path 
```bash
ln -s /var/www/html/node_modules/grunt-cli/bin/grunt /usr/local/bin/grunt
```
#### 7 - Exiting from Root User
```bash
exit
```
 <br />

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
 <br />

### Notes

`database name = magentodb`

`url = `http://my.magento.test

`admin url = `http://my.magento.test/admin

`admin username = admin`

`admin password = admin123`