#!/usr/bin/env bash
script_dir="$(dirname "$0")"
cd ${script_dir}

. imports.sh

OPTION_PROPAGATE=1

help_message

info "PhpUnit..."
if [[ ${EXEC} == 1 ]]
then
  if [[ ${COVERAGE} == 1 ]]
  then
    comment "Running tests with coverage..."
    docker-compose -f ${DOCKER_COMPOSE_FILE} exec app phpunit --coverage-html ${PHPUNIT_COVERAGE_HTML_REPORT} --coverage-text  \
      --coverage-clover ${PHPUNIT_COVERAGE_CLOVER_REPORT}
  else
    if [[ -z "$@" ]]
    then
        comment "Running tests..."
    fi
    docker-compose -f ${DOCKER_COMPOSE_FILE} exec app phpunit "$@"
  fi
else
  no-exec
fi


