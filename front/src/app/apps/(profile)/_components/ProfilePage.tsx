"use client";
import React from "react";

import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";

import ProfileCard from "@/app/apps/(profile)/_components/ProfileCard";
import AboutMe from "@/app/apps/(profile)/_components/AboutMe";
import { Container, Row, Col } from "reactstrap";
import { IconStack2 } from "@tabler/icons-react";
import { useAuth } from "@/lib/contexts/AuthContext";

const Profile = () => {
  const { user } = useAuth();

  return (
    <Container fluid>
      <Breadcrumbs
        mainTitle="Profile"
        title="Apps"
        path={["Profile Page", "Profile"]}
        Icon={IconStack2}
      />
      <Row>
        <Col lg="12" className="order--1-lg col-box-4">
          <ProfileCard user={user} />
          <AboutMe profile={user?.profile ?? null} />
        </Col>
      </Row>
    </Container>
  );
};

export default Profile;
