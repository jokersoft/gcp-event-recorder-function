terraform {
  required_version = ">= 0.14"
}

# Configure GCP project
provider "google" {
  project     = var.gcp_project
  region      = var.gcp_region
}
