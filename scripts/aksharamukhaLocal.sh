#aksharamukha local start 

nohup sh -c 'cd /var/www/aksharamukha/aksharamukha-back && .venv/bin/python3.12 main.py' > backend.log 2>&1 &

nohup sh -c 'cd /var/www/aksharamukha/aksharamukha-front && NODE_OPTIONS=--openssl-legacy-provider quasar dev' > frontend.log 2>&1 &


exit 0

#install 
# Download and install nvm:
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.3/install.sh | bash

# in lieu of restarting the shell
\. "$HOME/.nvm/nvm.sh"

# Download and install Node.js:
nvm install 22

# Verify the Node.js version:
node -v # Should print "v22.16.0".
nvm current # Should print "v22.16.0".

# Verify npm version:
npm -v # Should print "10.9.2".

cd ../
git clone git@github.com:virtualvinodh/aksharamukha.git


cd aksharamukha-back
python3.12 -m venv .venv
.venv/bin/pip install -r requirements.txt 
.venv/bin/pip install aksharamukha


cd ../aksharamukha-front/

vi quasar.conf.js

remove analytics option

vi src/mixins/ScriptMixin.js

replace 
        baseURL: '/api/',

with 
        baseURL: 'http://localhost:8085/api/',
