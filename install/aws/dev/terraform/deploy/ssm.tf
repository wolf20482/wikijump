resource "aws_ssm_parameter" "URL_DOMAIN" {
  name  = "wikijump-${var.environment}-URL_DOMAIN"
  type  = "String"
  value = var.web_domain
}

resource "aws_ssm_parameter" "DB_HOST" {
  name  = "wikijump-${var.environment}-DB_HOST"
  type  = "String"
  value = "database"
}

resource "aws_ssm_parameter" "URL_UPLOAD_DOMAIN" {
  name  = "wikijump-${var.environment}-URL_UPLOAD_DOMAIN"
  type  = "String"
  value = var.files_domain
}

resource "aws_ssm_parameter" "WIKIJUMP_API_RATE_LIMIT_SECRET" {
  name  = "wikijump-${var.environment}-API_RATE_LIMIT_SECRET"
  type  = "String"
  value = var.api_ratelimit_secret
  overwrite = true
}

data "aws_ssm_parameter" "API_ECR_URL" {
  name = "wikijump-${var.environment}-API_ECR_URL"
}

data "aws_ssm_parameter" "PHP_ECR_URL" {
  name = "wikijump-${var.environment}-PHP_ECR_URL"
}

data "aws_ssm_parameter" "NGINX_ECR_URL" {
  name = "wikijump-${var.environment}-NGINX_ECR_URL"
}

data "aws_ssm_parameter" "DB_ECR_URL" {
  name = "wikijump-${var.environment}-DB_ECR_URL"
}

data "aws_ssm_parameter" "ecs_ami" {
  name = "/aws/service/ecs/optimized-ami/amazon-linux-2/recommended/image_id"
}

data "aws_ssm_parameter" "TRAEFIK_EFS_ID" {
  name = "wikijump-${var.environment}-TRAEFIK_EFS_ID"
}

data "aws_ssm_parameter" "WIKIJUMP_API_RATE_LIMIT_SECRET" {
  name = "wikijump-${var.environment}-API_RATE_LIMIT_SECRET"
}
