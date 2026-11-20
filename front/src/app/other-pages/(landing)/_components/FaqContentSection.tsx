import React, { useState } from "react";
import { Button, Card, CardBody, Col, Container, Row } from "reactstrap";
import { IconBook2, IconHeadphones } from "@tabler/icons-react";
import SectionHeading from "@/app/other-pages/(landing)/_components/SectionHeading";

const FaqContentSection = () => {
  const [openAccordion, setOpenAccordion] = useState<string | null>(
    "nestingcollapseOne"
  );

  const toggleAccordion = (id: string) => {
    setOpenAccordion(openAccordion === id ? null : id);
  };

  return (
    <div>
      <Container>
        <SectionHeading
          title="Frequently Asked"
          highlight="Questions"
          description="Find answers to common questions about unlocking books and using our platform. If you need further assistance, our support team is here to help."
        />

        <Row className="align-items-center">
          <Col lg={4}>
            <Row>
              {/* Documentation Card */}
              <Col lg="12" sm="6" className="mb-3">
                <Card className="card-boxs">
                  <CardBody>
                    <div className="icon-boxs">
                      <IconBook2 size={18} />
                    </div>
                    <div className="box-content">
                      <h4>Whatsaapp</h4>
                      <p>
                        Join our WhatsApp community for real-time updates and
                        support.
                      </p>
                      <Button
                        color="primary"
                        target="_blank"
                        href="https://chat.whatsapp.com/CRMLEqwPgR7AFi90exHHgv?s=cl&p=a&mlu=0"
                      >
                        Join Now
                      </Button>
                    </div>
                  </CardBody>
                </Card>
              </Col>

              {/* Support Card */}
              <Col lg="12" sm="6">
                <Card className="card-boxs">
                  <CardBody>
                    <div className="icon-boxs">
                      <IconHeadphones size={18} />
                    </div>
                    <div className="box-content">
                      <h4>Need Help?</h4>
                      <p>Our support team is available 24/7 to assist you.</p>
                      <Button
                        color="primary"
                        target="_blank"
                        href="mailto:firstbornpublishing923@gmail.com"
                      >
                        Contact Support
                      </Button>
                    </div>
                  </CardBody>
                </Card>
              </Col>
            </Row>
          </Col>
          <Col lg={8}>
            <div className="landing-accordion">
              <div className="accordion app-accordion accordion-flush accordion-light-dark app-accordion-plus">
                {[
                  {
                    id: "nestingcollapseOne",
                    question: "How do I unlock a book?",
                    answer:
                      "Books are unlocked using points. Browse the book catalog, choose a book, and spend the required points to unlock it. Once unlocked, the book is added to your library and available to read anytime.",
                  },
                  {
                    id: "nestingcollapseTwo",
                    question: "What are points and how do I get them?",
                    answer:
                      "Points are the in-app currency used to unlock books. You purchase points through book plans. Each plan grants a specific number of points, which are credited to your account immediately after a successful payment.",
                  },
                  {
                    id: "nestingcollapseFour",
                    question: "What are book plans?",
                    answer:
                      "Book plans are purchasable packages that bundle points at different price tiers. Choose the plan that fits your reading needs, complete the payment, and the points are added to your balance. Plans may also include bonus points or discounts on larger purchases.",
                  },
                  {
                    id: "nestingcollapseFive",
                    question: "Can I unlock multiple books at once?",
                    answer:
                      "Yes. As long as you have enough points in your balance, you can unlock any number of books. Each book costs a set number of points, which is shown on the book detail page before unlocking.",
                  },
                  {
                    id: "nestingcollapseSix",
                    question: "Do unlocked books expire?",
                    answer:
                      "No. Once a book is unlocked with points, it stays in your library permanently and can be read offline or online at any time. Points, however, are non-refundable once spent.",
                  },
                  {
                    id: "nestingcollapseSeven",
                    question: "How do I check my points balance?",
                    answer:
                      "Your current points balance is shown on your account dashboard and profile page. It updates automatically after every purchase or book unlock.",
                  },
                  {
                    id: "nestingcollapseEight",
                    question: "Can I get a refund for unused points?",
                    answer:
                      "Points are non-refundable once purchased. Please choose your book plan carefully. If you experience issues with a purchase, contact support for assistance.",
                  },
                ].map((item) => (
                  <div className="accordion-item" key={item.id}>
                    <h2 className="accordion-header">
                      <button
                        className={`accordion-button ${openAccordion === item.id ? "" : "collapsed"}`}
                        type="button"
                        onClick={() => toggleAccordion(item.id)}
                      >
                        {item.question}
                      </button>
                    </h2>
                    <div
                      className={`accordion-collapse collapse ${openAccordion === item.id ? "show" : ""}`}
                    >
                      <div className="accordion-body">
                        <p>{item.answer}</p>
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </Col>
        </Row>
      </Container>
    </div>
  );
};

export default FaqContentSection;
