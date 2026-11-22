import Link from "next/link";

const Footer = () => {
  return (
    <>
      <footer>
        <div className="container-fluid">
          <div className="row">
            <div className="col-12">
              <ul className="footer-text">
                <li>
                  <Link href="#">Designed by aowebtech </Link>
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
