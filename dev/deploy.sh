#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
lessc "$DIR/../assets/less/application.less" "$DIR/../assets/css/application.css"
lessc "$DIR/../assets/less/admin.less" "$DIR/../assets/css/admin.css"
lessc "$DIR/../assets/less/index.less" "$DIR/../assets/css/index.css"
lessc "$DIR/../assets/less/index_mobile.less" "$DIR/../assets/css/index_mobile.css"
