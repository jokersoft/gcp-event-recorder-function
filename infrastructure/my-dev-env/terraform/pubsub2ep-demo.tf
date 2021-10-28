module "event_recorder_demo_pubsub2ep" {
  source = "git@gitlab.smartexpose.com:allmyhomes/devops/terraform-modules/pubsub2ep.git?ref=schema-validation"
  project = var.gcp_project
  push_entry_point = "https://schema-validation.requestcatcher.com/"
  name = "demo-schema-validation"
  dlq_topic_name = "projects/${var.gcp_project}/topics/DLQ-EventRecorder"
  pubsub_service_account_email = "service-${data.google_project.project.number}@gcp-sa-pubsub.iam.gserviceaccount.com"
  publisher_service_account_email = "${data.google_project.project.number}-compute@developer.gserviceaccount.com"
  schema_definition_string = file("schema.json")
}
