{
  network.description = "My Stupid-Simple WebSite";

  mspc =
    { stdenv, config, pkgs, ... }:
	let myActualContent = import ./application.nix; in
	{
	  environment.systemPackages = [
      pkgs.apacheHttpd
      myActualContent
	  ];

	  networking.firewall.allowedTCPPorts = [ 22 80 ];

	  services.openssh.enable = true;

	  services.httpd.enable       = true;
	  services.httpd.enablePHP    = true;
	  services.httpd.adminAddr    = "hhefesto@rdataa.com";
	  services.httpd.documentRoot = "${myActualContent}/web";

	  # users.extraUsers.root.openssh.authorizedKeys.keys = [
    #     "ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAAAIbmlzdHAyNTYAAABBBP5tbk8oBvjFqQN6fSirPVNYlioI4HXLNazEWczuBJQMq3Tn16ACADJIrgmA+jfGgKmFXBqcFfossPZA5lExUuo= greyson@astaroth"
	  # ];
	};
}
