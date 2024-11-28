# PHP 8.0 기반 Apache 이미지를 기반으로 새로운 이미지를 생성
FROM php:8.0-apache

# PHP 확장 모듈 설치: mysqli, pdo, pdo_mysql
# mysqli: MySQL 데이터베이스와 상호작용을 위한 확장
# pdo: PHP Data Objects 인터페이스
# pdo_mysql: PDO에서 MySQL 데이터베이스를 지원하기 위한 드라이버
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 컨테이너 내부 작업 디렉토리를 /var/www/html로 설정
# Apache의 기본 웹 서버 루트 디렉토리로 이동
WORKDIR /var/www/html

# 호스트 시스템의 현재 디렉토리(.)의 모든 파일을 컨테이너의 /var/www/html 디렉토리에 복사
COPY . /var/www/html/
