import Link from "next/link";
import { IconHelp } from "@tabler/icons-react";

const Footer = () => {
  return (
    <>
      <footer>
        <div className="container-fluid">
          <div className="row">
            <div className="col-md-9 col-12">
              <ul className="footer-text">
                <li>
                  <p className="mb-0">
                    Copyright © 2026 Leacent Books. All rights reserved 💖
                  </p>
                </li>
                <li>
                  <p className="mb-0 text-muted small">
                    If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing.
                  </p>
                </li>
                <li>
                  <Link href="#"> aowebtech </Link>
                </li>
              </ul>
            </div>
            <div className="col-md-3">
              <ul className="footer-text text-end">
                <li>
                  <Link href="/">
                    {" "}
                    Need Help <IconHelp size={14} />
                  </Link>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </>
  );
};

export default Footer;
