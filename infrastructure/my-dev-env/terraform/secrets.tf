data "google_secret_manager_secret_version" "db_password" {
  secret  = "EVENT_STORE_DB_PASSWORD"
  version = "1"
}
