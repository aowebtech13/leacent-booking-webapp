"use client";
import React, { useEffect, useState } from "react";

import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";

import ProfileCard from "@/app/apps/(profile)/_components/ProfileCard";
import AboutMe from "@/app/apps/(profile)/_components/AboutMe";
import FeaturedStories from "@/app/apps/(profile)/_components/FeaturedStories";
import { Container, Row, Col } from "reactstrap";
import { IconStack2 } from "@tabler/icons-react";
import { useAuth } from "@/lib/contexts/AuthContext";

const Profile = () => {
  const { user, isLoading } = useAuth();
  const [data, setData] = useState<string>("1");

  if (isLoading) {
    return (
      <Container fluid className="d-flex align-items-center justify-content-center" style={{ minHeight: "60vh" }}>
        <div className="text-center">
          <div className="spinner-border text-primary" role="status">
            <span className="visually-hidden">Loading...</span>
          </div>
        </div>
      </Container>
    );
  }

  return (
    <Container fluid>
      <Breadcrumbs
        mainTitle="Profile"
        title="Apps"
        path={["Profile Page", "Profile"]}
        Icon={IconStack2}
      />
      <Row>
        <FeaturedStories data={data} />

        <Col lg="12" className="order--1-lg col-box-4">
          <ProfileCard user={user} />
          <AboutMe profile={user?.profile ?? null} />
        </Col>
      </Row>
    </Container>
  );
};

export default Profile;
