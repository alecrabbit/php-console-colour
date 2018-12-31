#!/usr/bin/env bash
COVERAGE=0
PROPAGATE=0
ANALYZE=0
BEAUTY=0
EXEC=1
HELP=0
RESTART_CONTAINER=1

#echo "$@" # for debug
for arg
do
    case "$arg" in
        --propagate)
            PROPAGATE=1
            ;;
     esac
done

for arg
do
    case "$arg" in
        --help)
            HELP=1
            if [[ ${PROPAGATE} == 1 ]]
                then
                    params+=("$arg")
            fi
            ;;
        --no-exec)
            EXEC=0
            ;;
        --no-restart)
            RESTART_CONTAINER=0
            ;;
        --analyze)
            ANALYZE=1
            ;;
        --coverage)
            COVERAGE=1
            ;;
        --propagate)
            PROPAGATE=1
            ;;
        --beauty)
            BEAUTY=1
            ;;
        --beautify)
            BEAUTY=1
            ;;
        --all)
            ANALYZE=1
            COVERAGE=1
            BEAUTY=1
            ;;
        *)
            if [[ ${PROPAGATE} == 1 ]]
                then
                    params+=("$arg")
                else
                    echo "settings.sh: Unknown argument/option ${arg}"
                    exit 0
            fi
            ;;
     esac
done
set -- "${params[@]}"  # overwrites the original positional params
#echo "$@" # for debug

SOURCE_DIR="src"
PHPSTAN_LEVEL=7
PSALM_CONFIG="./../psalm.xml"
PSALM_LEVEL=3
TESTS_DIR="tests"
TMP_DIR_PARTIAL="tmp"
TMP_DIR="./${TESTS_DIR}/${TMP_DIR_PARTIAL}"
PHPMETRICS_DIR="phpmetrics"
COVERAGE_DIR="coverage"
PHPMETRICS_OUTPUT_DIR="${TMP_DIR}/${PHPMETRICS_DIR}"
PHPUNIT_COVERAGE_HTML_REPORT="${TMP_DIR}/${COVERAGE_DIR}/html"
PHPUNIT_COVERAGE_CLOVER_REPORT="${TMP_DIR}/${COVERAGE_DIR}/clover.xml"
TEST_REPORT_INDEX="./../${TESTS_DIR}/report.html"
HEADER="$(basename $(dirname "$(pwd)"))"

if [[ ${COVERAGE} == 1 ]]
then
  DOCKER_COMPOSE_FILE="./../docker-compose-debug.yml"
else
  DOCKER_COMPOSE_FILE="./../docker-compose.yml"
fi

DOCKER_ENV_FILE="./../.env"

