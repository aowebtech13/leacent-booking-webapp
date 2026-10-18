import React from "react";
import {
  IconBrandGithub,
  IconBriefcase,
  IconCake,
  IconDeviceLaptop,
  IconMail,
  IconMapPin,
  IconPhone,
} from "@tabler/icons-react";
import { Card, CardBody, CardHeader, Col, Row } from "reactstrap";

interface AboutMeProps {
  profile?: {
    company_name?: string | null;
    phone_number?: string | null;
    address?: string | null;
    about_me?: string | null;
    email?: string | null;
  } | null;
}

const AboutMe = ({ profile }: AboutMeProps) => {
  const company = profile?.company_name || "IT Section";
  const email = profile?.email || "Ninfa@gmail.com";
  const phone = profile?.phone_number || "0364 4559103";
  const address = profile?.address || "Via Partenope, 117";
  const about = profile?.about_me || null;

  const aboutItems = [
    {
      icon: <IconBriefcase size={18} />,
      label: "Work passion",
      value: company,
    },
    {
      icon: <IconMail size={18} />,
      label: "Email",
      value: email,
    },
    {
      icon: <IconPhone size={18} />,
      label: "Contact",
      value: phone,
    },
    {
      icon: <IconCake size={18} />,
      label: "Birth of Date",
      value: "24 Oct",
    },
    {
      icon: <IconMapPin size={18} />,
      label: "Location",
      value: address,
    },
    {
      icon: <IconDeviceLaptop size={18} />,
      label: "Website",
      value: "Ninfa_devWWW.com",
    },
    {
      icon: <IconBrandGithub size={18} />,
      label: "Github",
      value: "Ninfa_dev",
    },
  ];

  return (
    <Card>
      <CardHeader>
        <h5>About Me</h5>
      </CardHeader>
      <CardBody>
        {about && (
          <p className="text-muted f-s-13 mb-4">{about}</p>
        )}
        <div className="about-list">
          {aboutItems.map((item, idx) => (
            <Row key={idx} className="mb-2 align-items-center">
              <Col xs="6">
                <span className="fw-semibold d-flex align-items-center gap-2">
                  {item.icon} {item.label}
                </span>
              </Col>
              <Col xs="6" className="text-end text-secondary small">
                {item.value}
              </Col>
            </Row>
          ))}
        </div>
      </CardBody>
    </Card>
  );
};

export default AboutMe;
