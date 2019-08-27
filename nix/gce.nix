{
  mspc =
    { deployment.targetEnv = "gce";
      deployment.gce = {
        # credentials
        project = "mspatientcare-251022";
        serviceAccount = "mspatientcare@mspatientcare-251022.iam.gserviceaccount.com";
        accessKey = "~/.ssh/mspatientcare-gce-key.json";

        # instance properties
        region = "us-west2-a";
        instanceType = "n1-standard-1";
        tags = ["crazy2"];
        scheduling.automaticRestart = true;
        scheduling.onHostMaintenance = "MIGRATE";

        rootDiskSize = 10;
      } ;
    };
}
