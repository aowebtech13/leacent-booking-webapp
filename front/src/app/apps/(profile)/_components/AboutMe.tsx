import React from "react";
import {
  IconBriefcase,
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
  const about = profile?.about_me || null;

  const aboutItems: Array<{
    icon: React.ReactNode;
    label: string;
    value: string | null;
  }> = [
    {
      icon: <IconBriefcase size={18} />,
      label: "Company Name",
      value: profile?.company_name || null,
    },
    {
      icon: <IconMail size={18} />,
      label: "Email Address",
      value: profile?.email || null,
    },
    {
      icon: <IconPhone size={18} />,
      label: "Contact Number",
      value: profile?.phone_number || null,
    },
    {
      icon: <IconMapPin size={18} />,
      label: "My Location",
      value: profile?.address || null,
    },
    {
      icon: <IconDeviceLaptop size={18} />,
      label: "Website",
      value: null,
    },
  ];

  const hasData = aboutItems.some((item) => item.value) || about;

  if (!hasData) {
    return null;
  }

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
          {aboutItems
            .filter((item) => item.value)
            .map((item, idx) => (
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
