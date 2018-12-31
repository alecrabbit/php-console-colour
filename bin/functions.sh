#!/usr/bin/env bash

header () {
    printf "${LIGHT_GRAY}${1}${NC}\n"
}

info () {
    printf "\n${GREEN}${1}${NC}\n\n"
}

error () {
    printf "\n${RED}${1}${NC}\n\n"
}

comment () {
    printf "\n${YELLOW}${1}${NC}\n\n"
}

no-exec () {
    comment "No-Exec..."
}

enabled () {
    echo " enabled."
}
disabled () {
    echo " disabled."
}

help_message () {
if [[ ${HELP} == 1 ]]
then
    echo "Options:"
    echo "  --help          - show this message"
    [[ $OPTION_NO_RESTART ]] && echo "  --no-restart    - do not restart container(may cause 'No coverage driver')"
    [[ $OPTION_ANALYZE ]] && echo "  --analyze       - enable analysis"
    [[ $OPTION_COVERAGE ]] && echo "  --coverage      - enable code coverage"
    [[ $OPTION_ALL ]] && echo "  --all           - enable analysis and code coverage"
    [[ $OPTION_BEAUTY ]] && echo "  --beautify      - enable code beautifier"
    [[ $OPTION_BEAUTY ]] && echo "  --beauty        - same as above"
    [[ $OPTION_PROPAGATE ]] && echo "  --propagate     - propagate unrecognized options to underlying script"
    if [[ ${PROPAGATE} == 0 ]]
    then
        exit 0
    fi
fi
}

options_enabled () {
    printf "Analysis"
    if [[ ${ANALYZE} == 1 ]]
    then
        enabled
    else
        disabled
    fi
    printf "Coverage"
    if [[ ${COVERAGE} == 1 ]]
    then
        enabled
    else
        disabled
    fi
    printf "Beautifier"
    if [[ ${BEAUTY} == 1 ]]
    then
        enabled
    else
        disabled
    fi
    printf "Container restart"
    if [[ ${RESTART_CONTAINER} == 1 ]]
    then
        enabled
    else
        disabled
    fi

}

generate_report_file () {
    echo "<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <title>${HEADER}</title>
</head>
<body>

<h1>Report &lt;${HEADER}&gt;</h1>

<p>Some links could be empty</p>
<a href='${TMP_DIR_PARTIAL}/${COVERAGE_DIR}/html/index.html'>Coverage report</a><br>
<a href='${TMP_DIR_PARTIAL}/${PHPMETRICS_DIR}/index.html'>Phpmetrics report</a><br>

</body>
</html>" > ${TEST_REPORT_INDEX}
}
