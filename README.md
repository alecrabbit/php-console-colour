# PHP Console Colour
based on JakubOnderka/PHP-Console-Color

changes related to usage in docker container on Linux systems

```dockerfile
...
    environment:
      DOCKER_TERM: "$TERM"  # Pass $TERM var to container
...

```

