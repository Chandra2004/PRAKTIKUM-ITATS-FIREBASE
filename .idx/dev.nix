{ pkgs, ... }: {
  channel = "stable-24.05";
  packages = [
    pkgs.php83
    pkgs.php83Packages.composer
    pkgs.nodejs_20
    pkgs.python3
    pkgs.tailwindcss
  ];
  services.mysql = {
    enable = true;
    package = pkgs.mariadb;
  };
  env = {
    PHP_PATH = "${pkgs.php83}/bin/php";
  };
  idx = {
    extensions = [];
    previews = {
      enable = true;
      previews = {
        web = {
          command = ["php" "-S" "localhost:$PORT" "server.php"];
          manager = "web";
        };
      };
    };
    workspace = {
      onCreate = {
        default.openFiles = ["index.php"];
      };
      onStart = {
        run-server = "php artisan serve";
      };
    };
  };
}