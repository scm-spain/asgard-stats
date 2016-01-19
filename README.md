
Installation:

```bash
$ php composer.phar install --prefer-dist -o
```


Usage:

```bash
$ php asgard-stats weekly [environment]
```

Example:

```bash
$ php asgard-stats weekly dev
```

Settings file "config.yml":

```yaml
environments:
  dev: http://asgard.yourdomain.dev/eu-west-1/task/list.json
  pro: http://asgard.yourdomain.com/eu-west-1/task/list.json
```