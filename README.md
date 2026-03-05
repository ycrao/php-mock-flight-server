php-mock-flight-server
----------------------

>   A php mock server (admin backend) by flightphp for [ai-simple-react-antd-admin](https://github.com/ycrao/ai-simple-react-antd-admin) .


## Usage

```bash
# terminal 1
# admin backend (mock server) php-mock-flight-server
# need php8+ runtime
git clone https://github.com/ycrao/php-mock-flight-server.git
cd php-mock-flight-server
composer install -vvv
cp -r app/config/config_sample.php app/config/config.php
composer start

# terminal 2
# admin frontend ai-simple-react-antd-admin
# need node v22+ runtime with pnpm
git clone https://github.com/ycrao/ai-simple-react-antd-admin.git
cd ai-simple-react-antd-admin
# using pnpm package
pnpm i
pnpm dev
# or using npm
npm install
npm run dev
```

### Screenshorts

See [ai-simple-react-antd-admin](https://github.com/ycrao/ai-simple-react-antd-admin) repo.

### License

MIT