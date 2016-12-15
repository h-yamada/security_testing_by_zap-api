DockerとZAP APIを利用して脆弱性試験サンプル

# 構成

```
security_testing_by_zap-api/
├── RAEADME.md
├── attack #php-owasp-zap-v2でZAP APIを介して脆弱性診断
│   ├── Dockerfile
│   ├── attack.php
│   ├── composer.json
│   ├── composer.lock
│   └── composer.phar
├── docker-compose.yml
├── faraday #脆弱性監査レポート
│   ├── Dockerfile
│   └── docker-compose.yml
├── php7fpm #診断対象用テストサイト(XSSがあるくそサイト)
│   ├── Dockerfile
│   ├── index.php
│   └── printpost.php
├── report #診断後に出力され、faradayが参照するxml置き場
│   └── workspace
│       ├── process
│       └── unprocessed
└── testsite #診断対象用テストサイトのnginx
    ├── Dockerfile
    └── server.conf
```

# 概要


1. attackからzapを経由してtestsiteに対して脆弱性診断を実施
2. 診断結果xmlをreport/workspaceに格納
3. faradayで結果を閲覧


# イメージ作成

docker-compose build

# コンテナ起動

docker-compose up -d

# Faraday起動

```
docker run -it -p 5984:5984 -v $PWD/report/workspace/:/root/.faraday/report/workspace/ infobyte/faraday /root/run.sh
```

http://127.0.0.1:5984/_ui/#/dashboard/ws/workspace

# スキャン実施

```
docker run -it --rm --link=zap2 --link=testsite -v $PWD/report:/home/attacker/report -u attacker securitytestingbyzapapi_attack php ./attack.php
```
