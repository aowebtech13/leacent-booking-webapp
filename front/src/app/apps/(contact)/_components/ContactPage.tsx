"use client";
import React, { useState } from "react";
import {
  Card,
  CardBody,
  CardHeader,
  Col,
  Container,
  Row,
  Button,
  Spinner,
  Alert,
  FormGroup,
  Label,
  Input,
  Form,
} from "reactstrap";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import { sendContactMessage } from "@/lib/api/contact";
import {
  IconMail,
  IconHelp,
  IconBook,
  IconSend,
  IconCheck,
} from "@tabler/icons-react";
import Link from "next/link";

const ContactPage = () => {
  const [form, setForm] = useState({
    name: "",
    email: "",
    phone: "",
    subject: "",
    message: "",
  });
  const [isSending, setIsSending] = useState(false);
  const [feedback, setFeedback] = useState<{
    type: "success" | "danger";
    message: string;
  } | null>(null);

  const handleChange = (
    e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>
  ) => {
    setForm((prev) => ({ ...prev, [e.target.name]: e.target.value }));
  };

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    if (isSending) return;
    setIsSending(true);
    setFeedback(null);
    try {
      const res = await sendContactMessage({
        name: form.name.trim(),
        email: form.email.trim(),
        phone: form.phone.trim() || undefined,
        subject: form.subject.trim() || undefined,
        message: form.message.trim(),
      });
      setFeedback({
        type: "success",
        message:
          (res as any)?.message || "Your message has been sent successfully!",
      });
      setForm({ name: "", email: "", phone: "", subject: "", message: "" });
    } catch (err: any) {
      setFeedback({
        type: "danger",
        message:
          err?.message || "Failed to send your message. Please try again.",
      });
    } finally {
      setIsSending(false);
    }
  };

  return (
    <div className="contact-page">
      <Container fluid>
        <Breadcrumbs
          mainTitle="Contact Us"
          title="Apps"
          path={["Contact"]}
          Icon={IconMail as any}
        />

        {feedback && (
          <Alert
            color={feedback.type}
            className="mb-4 d-flex align-items-center"
            toggle={() => setFeedback(null)}
          >
            {feedback.type === "success" && (
              <IconCheck size={20} className="me-2" />
            )}
            <span>{feedback.message}</span>
          </Alert>
        )}

        <Row className="g-4">
          <Col lg={8}>
            <Card className="shadow-sm h-100">
              <CardHeader>
                <h5 className="mb-0">Send us a message</h5>
              </CardHeader>
              <CardBody>
                <p className="text-muted">
                  Have a question, suggestion, or need help with your account?
                  Fill in the form below and our team will get back to you as
                  soon as possible.
                </p>
                <Form onSubmit={handleSubmit}>
                  <Row className="g-3">
                    <Col md={6}>
                      <FormGroup>
                        <Label for="contactName">
                          Name <span className="text-danger">*</span>
                        </Label>
                        <Input
                          id="contactName"
                          name="name"
                          type="text"
                          placeholder="Your full name"
                          value={form.name}
                          onChange={handleChange}
                          required
                          maxLength={255}
                        />
                      </FormGroup>
                    </Col>
                    <Col md={6}>
                      <FormGroup>
                        <Label for="contactEmail">
                          Email <span className="text-danger">*</span>
                        </Label>
                        <Input
                          id="contactEmail"
                          name="email"
                          type="email"
                          placeholder="you@example.com"
                          value={form.email}
                          onChange={handleChange}
                          required
                          maxLength={255}
                        />
                      </FormGroup>
                    </Col>
                    <Col md={6}>
                      <FormGroup>
                        <Label for="contactPhone">Phone</Label>
                        <Input
                          id="contactPhone"
                          name="phone"
                          type="tel"
                          placeholder="Optional"
                          value={form.phone}
                          onChange={handleChange}
                          maxLength={20}
                        />
                      </FormGroup>
                    </Col>
                    <Col md={6}>
                      <FormGroup>
                        <Label for="contactSubject">Subject</Label>
                        <Input
                          id="contactSubject"
                          name="subject"
                          type="text"
                          placeholder="What is this about?"
                          value={form.subject}
                          onChange={handleChange}
                          maxLength={255}
                        />
                      </FormGroup>
                    </Col>
                    <Col xs={12}>
                      <FormGroup>
                        <Label for="contactMessage">
                          Message <span className="text-danger">*</span>
                        </Label>
                        <Input
                          id="contactMessage"
                          name="message"
                          type="textarea"
                          rows={6}
                          placeholder="Type your message here..."
                          value={form.message}
                          onChange={handleChange}
                          required
                          maxLength={2000}
                        />
                      </FormGroup>
                    </Col>
                    <Col xs={12}>
                      <Button
                        type="submit"
                        color="primary"
                        disabled={isSending}
                      >
                        {isSending ? (
                          <>
                            <Spinner size="sm" className="me-1" /> Sending…
                          </>
                        ) : (
                          <>
                            <IconSend size={18} className="me-1" /> Send Message
                          </>
                        )}
                      </Button>
                    </Col>
                  </Row>
                </Form>
              </CardBody>
            </Card>
          </Col>

          <Col lg={4}>
            <Card className="shadow-sm mb-4">
              <CardHeader>
                <h5 className="mb-0">Quick links</h5>
              </CardHeader>
              <CardBody>
                <div className="d-flex flex-column gap-3">
                  <Link
                    href="/apps/faq"
                    className="d-flex align-items-center text-decoration-none text-reset"
                  >
                    <span className="text-primary me-2">
                      <IconHelp size={20} />
                    </span>
                    <div>
                      <div className="fw-medium">FAQ</div>
                      <small className="text-muted">
                        Find answers to common questions.
                      </small>
                    </div>
                  </Link>
                  <Link
                    href="/apps/book-library"
                    className="d-flex align-items-center text-decoration-none text-reset"
                  >
                    <span className="text-primary me-2">
                      <IconBook size={20} />
                    </span>
                    <div>
                      <div className="fw-medium">Book Library</div>
                      <small className="text-muted">
                        Browse and read available books.
                      </small>
                    </div>
                  </Link>
                </div>
              </CardBody>
            </Card>

            <Card className="shadow-sm">
              <CardBody>
                <div className="d-flex align-items-start">
                  <span className="text-primary me-2">
                    <IconMail size={22} />
                  </span>
                  <div>
                    <h6 className="mb-1">Business Lab</h6>
                    <p className="text-muted small mb-0">
                      Books &amp; Movies platform. We aim to respond to all
                      messages within 1-2 business days.
                    </p>
                  </div>
                </div>
              </CardBody>
            </Card>
          </Col>
        </Row>
      </Container>
    </div>
  );
};

export default ContactPage;
