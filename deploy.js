const FtpDeploy = require("ftp-deploy");
const ftpDeploy = new FtpDeploy();

const config = {
    user: "modhost",
    host: "butiqhosting.com",
    port: 21,
    localRoot: __dirname,
    remoteRoot: "/domains/ygm.butiqhosting.com/public_html/wp-content/plugins/",
    include: ["*", "**/*"],
    exclude: ["node_modules/**", ".git/**", ".gitignore", "deploy.js", "package*"],
    deleteRemote: false
};

ftpDeploy
    .deploy(config)
    .then(res => console.log("✅ Deploy tamamlandı!", res))
    .catch(err => console.error("❌ Deploy hatası:", err));
