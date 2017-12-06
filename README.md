Advent of Code Leaderboard Day-by-day
=====================================

Config
------
Find you session cookie from the AoC website and add the value of the cookie into the config/session.txt file.

Usage
-----

```
docker run --rm -it -v $(pwd):/app -p 8081:8081 php:7.1-cli php -t /app/public -S 0.0.0.0:8081
```

Open a web browser and point it to http://localhost:8081/?id=your-private-leaderboard-id&year=2017.
