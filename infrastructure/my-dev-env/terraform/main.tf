terraform {
  backend "gcs" {
    bucket = "terraform-lock"
    prefix = "my-dev-env/event-recorder"
  }
}

data "google_project" "project" {
  project_id = var.gcp_project
}

//module "event_recorder_function" {
//  source = "git@gitlab.TODO/cloud-function.git?ref=master"
//  cloud_function_name = "event-recorder"
//  cloud_function_description = "Event Recorder Function"
//  project = var.gcp_project
//  entry_point = "record"
//  artifact_version = var.git_commit_short
//  # allow unauthenticated for template demo/testing purposes:
//  iam_members = ["allUsers"]
//  # iam_members = ["serviceAccount:TODO-compute@developer.gserviceaccount.com"]
//  environment_variables = {
//    DB_NAME = "prototype-cms"
//    DB_USER = "prototype-cms"
//    DB_PASSWORD = data.google_secret_manager_secret_version.db_password.secret_data
//    CONNECTION_NAME = "my-dev-env:europe-west3:main-postgres"
//    TOPIC = "test_topic_table"
//  }
//}

//module "event_recorder_list_function" {
//  source = "git@gitlab.TODO/cloud-function.git?ref=master"
//  cloud_function_name = "event-recorder-list"
//  cloud_function_description = "Event Recorder Function list EP"
//  project = var.gcp_project
//  entry_point = "listEvents"
//  artifact_storage_folder = "event-recorder"
//  artifact_version = var.git_commit_short
//  # allow unauthenticated for template demo/testing purposes:
//  iam_members = ["allUsers"]
//  # iam_members = ["serviceAccount:TODO-compute@developer.gserviceaccount.com"]
//  environment_variables = {
//    DB_NAME = "prototype-cms"
//    DB_USER = "prototype-cms"
//    DB_PASSWORD = data.google_secret_manager_secret_version.db_password.secret_data
//    CONNECTION_NAME = "my-dev-env:europe-west3:main-postgres"
//    TOPIC = "test_topic_table"
//  }
//}

//module "event_recorder_prune_function" {
//  source = "git@gitlab.TODO/cloud-function.git?ref=master"
//  cloud_function_name = "event-recorder-prune"
//  cloud_function_description = "Event Recorder Function prune EP"
//  project = var.gcp_project
//  entry_point = "prune"
//  artifact_storage_folder = "event-recorder"
//  artifact_version = var.git_commit_short
//  # allow unauthenticated for template demo/testing purposes:
//  iam_members = ["allUsers"]
//  # iam_members = ["serviceAccount:TODO-compute@developer.gserviceaccount.com"]
//  environment_variables = {
//    DB_NAME = "prototype-cms"
//    DB_USER = "prototype-cms"
//    DB_PASSWORD = data.google_secret_manager_secret_version.db_password.secret_data
//    CONNECTION_NAME = "my-dev-env:europe-west3:main-postgres"
//    TOPIC = "test_topic_table"
//  }
//}
