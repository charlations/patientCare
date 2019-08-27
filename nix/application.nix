with import <nixpkgs> {};

stdenv.mkDerivation {
  name = "myWebApplication";
  src  = ./data;
  installPhase = ''
    mkdir -p "$out/web"
    cp -ra * "$out/web"
  '';
}
