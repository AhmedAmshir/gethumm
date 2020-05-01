pipeline {
    agent {
        dockerfile true
    }
    stages {
        stage("Build") {
            steps {
                sh 'php --version'
                sh 'composer install'
                sh 'composer --version'
                sh 'cp .env.example .env'
                sh 'php artisan key:generate'
            }
        }
        stage("Unit test") {
            steps {
                script {
                    docker.image('mysql:5.7').withRun('-e "DB_HOST=gethumm_mysql" -e "MYSQL_DATABASE=gethumm_testing" -e "DB_USERNAME=root" -e "DB_PASSWORD=root" -p 3305:3305"') {
                        sh "./vendor/bin/phpunit --filter=HummTest"
                    }
                }
            }
        }
    }
}
