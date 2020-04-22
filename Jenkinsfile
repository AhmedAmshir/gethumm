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
            }
        }
        stage("Unit test") {
            steps {
                sh "./vendor/bin/phpunit --filter=CalculatorTest"
            }
        }
    }
}
