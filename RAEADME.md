DockerとZAP APIを利用して脆弱性試験を効率的に行なうサンプル

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
