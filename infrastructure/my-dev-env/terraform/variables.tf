# define GCP region
variable "gcp_region" {
  type        = string
  description = "GCP region"
}

# define GCP project name
variable "gcp_project" {
  type        = string
  description = "GCP project name"
}

# Used to deploy image by short commit id
variable "git_commit_short" {
  type        = string
  description = "Example secret variable to propagate to app env"
}
