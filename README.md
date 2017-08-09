## Open Ports through Web Interface and iptables
If you have protected your ports, such as Port 22 of SSH, via `iptables` and allow only access to few static IPs, then it generally is difficult to connect to it when you are on the move.

The script `openport.php` allows you to have a password protected web interface available, that will open the SSH port dynamically for your IP Address via iptables.

## How it works

1. You need to allow access to `iptables` via the web server user (such as `www-data` on Ubuntu), without a password.
2. You need to publish the `openport.php` script on a secure `https://` interface on the web server
3. Whenever you need access, just visit the webpage, enter your password, and open access.

## 1. The `sudo` access
Edit the `sudoers` file
```
sudo visudo
```
At the end of the file, add the following
```
www-data ALL=NOPASSWD: /sbin/iptables
```
The line above allows www-data access to the command iptables, without a password.

Verify if `sudo` is indeed working for `www-data` user.

Run the following command to verify.
```
sudo -H -u www-data bash -c 'sudo iptables -L'
```

Note: It should not ask any password for `www-data` and show the data related to `iptables`.

## 2. The `web` access
Put the contents of `openport.php` on a secure location on your web server.

Change the password as per your preference, along with the Port number if required.

Access the web page whenever you need to grant access to the port from a different IP.


## Maintenance

* The ports that you open via the script tend to remain open like forever. You should ideally setup a firewall script via iptables and reset the rules at a pre-defined interval.
* For RDP and other ports that are not on the same machine, but are within the same network, you can setup Port Forwarding based on iptables and do the relevant NAT based redirection.

More information at https://exain.wordpress.com/2017/08/09/how-to-securely-open-ports-ssh-rdp-etc-on-demand-for-dynamic-ips-through-iptables
